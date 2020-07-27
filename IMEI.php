<?php


namespace IMEI;


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
            $n = \App\Packages\IMEI\Models\Imei::query()->where('TAC',$code_country.$model)->latest('amount')->get()[0]->amount;
            $result = $result . (string)(999999 - $n);
            $c = $this->controlNumber($result);
            $result = $result .  $this->controlNumber($result);
        }
        catch (\Exception $exception){
            $n = 0;
            $result = $result . '999999' ;
            $result = $result . $this->controlNumber($result);
        }
        \App\Packages\IMEI\Models\Imei::query()->create([
            'TAC' => $code_country . $model,
            'CC' => substr($result, 8, 6),
            'D' => $result[14],
            'amount' => $n + 1
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

}
