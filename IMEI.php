<?php


namespace App\Packages\IMEI;


class IMEI
{
    /**
     * @param string $code_country
     * @param string $model
     * @return string
     */
    public function generateIMEI($code_country, $model){
        $result = $code_country . $model;
        for ($i = 0; $i < 6; $i++){
            $n = rand(0,9);
            $result = $result . $n;
        }
        $result = $result . $this->controlNumber($result);

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
