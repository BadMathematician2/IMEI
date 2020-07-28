<?php


namespace IMEI;


use App\Packages\IMEI\src\Exceptions\AmountOfIMEIException;
use App\Packages\IMEI\src\Exceptions\InvalidCodeException;
use IMEI\Models\Phone;

class IMEI
{
    /**
     * @param string $code
     * @return string
     * @throws InvalidCodeException
     */
    public function generateIMEI($code){
        if (!$this->checkCode($code))
        {
            throw new InvalidCodeException('Invalid code. It must be eight whole numbers');
        }
        $result = $code;
        try {
            $exists = Phone::query()->where('TAC',$code)->get();

            if (!$this->checkSize($exists))
                throw new AmountOfIMEIException('In base all possible IMEIs already exist.');

            $k = 0;
            do {
                $k++;
                $CC = '';
                for ($i = 0; $i < 6; $i++)
                    $CC = $CC . rand(0, 9);
            }
            while ($this->isInArray($exists,$CC)&&$k<1000000);

            $result = $result .  $this->controlNumber($result . $CC);
        }
        catch (\Exception $exception){
            $CC = '';
            for ($i = 0; $i < 6; $i++) {
                $CC = $CC . rand(0, 9);
            }
            $result = $result . $CC;
            $result = $result . $this->controlNumber($result);
        }

        Phone::query()->create([
            'TAC' => $code,
            'CC' => substr($result, 8, 6),
            'D' => $result[14]
        ]);

        return $result;
    }

    /**
     * @param string $code
     * @return bool
     */
    private function checkCode($code)
    {
        if (strlen($code) != 8 || ((float)$code!=(int)$code) )
            return false;
        else return true;
    }

    /**
     * @param array $exists
     * @return bool
     */
    private function checkSize($exists)
    {
        if (sizeof($exists) < 1000000)
            return false;
        else return true;
    }
    public function resetTable()
    {
        Phone::query()->delete();
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

    /**
     * @param $exists
     * @param string $CC
     * @return bool
     */
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
