<?php


namespace IMEI;


use IMEI\Models\Phone;

class IMEI
{
    /**
     * @param string $code_country
     * @param string $model
     * @return string
     */
    public function generateIMEI($code_country, $model){
        if (strlen($code_country) != 2 || !is_numeric($code_country) && (int)$code_country != (float)$code_country )
            return 'Country code must have exactly two numbers';
        if (strlen($model) != 6 || !is_numeric($model) || (int)$model != (float)$model )
            return 'Country code must have exactly six numbers';
        $result = $code_country . $model;
        try {
            $exists = Phone::query()->where('TAC',$code_country.$model)->get();
            do {
                $CC = '';
                for ($i = 0; $i < 6; $i++)
                    $CC = $CC . rand(0, 9);
            }
            while ($this->isInArray($exists,$CC));
            $result = $result . $CC;
            $result = $result .  $this->controlNumber($result);
        }
        catch (\Exception $exception){
            $CC = '';
            for ($i = 0; $i < 6; $i++)
                $CC = $CC . rand(0, 9);
            $result = $result . $CC;
            $result = $result . $this->controlNumber($result);
        }
        Phone::query()->create([
            'TAC' => $code_country . $model,
            'CC' => substr($result, 8, 6),
            'D' => $result[14]
        ]);

        return $result;
    }

    /**
     * @param string $code
     * @return bool
     */
    private function controlNumber($code){
        $sum = 0;
        for ($i = 0; $i < strlen($code); $i++){
            if ($i%2==0)
                $sum += (int)$code[$i];
            else {
                $t = (int)$code[$i] * 2;
                if ($t >= 10) $t -= 9;
                $sum += $t;
            }
        }

        if ($sum%10===0)
            return 0;
        else
            return 9*$sum%10;
    }

    private function isInArray($exists, $CC)
    {
        $result = false;
        foreach ($exists as $exist)
            if ($exist->CC == $CC){
                $result = true;
                break;
            }
        return $result;
    }
}
