<?php
    protected static function getGroupColors()
    {
        return [
            //ImageHelper::hexToRGB('00a1d6')
            'platinum' => [
                'red'   => 0,
                'green' => 161,
                'blue'  => 214
            ],
            //ImageHelper::hexToRGB('8F8')
            'vip' => [
                'red'   => 136,
                'green' => 255,
                'blue'  => 136,
            ],

            //ImageHelper::hexToRGB('FFD700'),
            'premium' => [
                'red'   => 255,
                'green' => 215,
                'blue'  => 0,
            ],
            // 'mods'     => ImageHelper::hexToRGB('F77'),
            'mods' => [
                'red'   => 255,
                'green' => 119,
                'blue'  => 119,
            ],

            //'guest'    => ImageHelper::hexToRGB('FFF'),
            'guest' => [
                'red'   => 255,
                'green' => 255,
                'blue'  => 255,
            ],
            //'girls'    => ImageHelper::hexToRGB('F6F'),
            'girls'      => [
                'red' => 255,
                'green' => 102,
                'blue' => 255,
            ],
            //'admins'   => ImageHelper::hexToRGB('F44'),
            'admins'      => [
                'red'   => 255,
                'green' => 68,
                'blue'  => 68,
            ],
        ];
    }

    public function actionTest()
    {
        $colors = self::getGroupColors();

        $width  = 380;
        $minHeight = 20;

        $garants = [
            0 => ['Panya', 'Pirate Station', 'platinum'],
            1 => ['InnoooK', 'Nano', 'platinum'],
            2 => ['Shredder', 'Nano', 'platinum'],
            3 => ['TR0L12', 'Demo', 'vip'],
            4 => ['Garys' . time(), 'Demo', 'mods'],
            5 => ['snot15', 'Demo', 'premium'],
            6 => ['Admin', 'Demo', 'admins'],
            7 => ['TheLos', 'Demo', 'mods'],
            8 => ['GuarantSupport', 'Demo', 'guest'],
            10 => ['Astronaut', 'В блоке', 'girls'],
            11 => ['nu_emil_dopustim_tatar', 'В блоке', 'vip'],
        ];

        $countGarants = count($garants);

        $lineHeight = 18;
        $height = $countGarants * $lineHeight;

        if ($minHeight > $height) {
            $height = $minHeight;
        }

        $img   = imagecreatetruecolor($width, $height) or die('Error generate image resource');
        $whiteColor = imagecolorallocate($img, 255, 255, 255);

        $transparent = imagecolorallocatealpha($img, 0, 0, 0, 127);
        imagefill($img, 0, 0, $transparent);

        imagesavealpha($img, true);
        $fontPath = 'fonts/consola.ttf'; //fonts/arial.ttf
        $currentHeightLine = 0;

        if ($countGarants == 0) {
            imagefttext($img, 10, 0, 5, $currentHeightLine + 13, $whiteColor, $fontPath, "Гарантов нет в сети :(");
        }

        $fontSize = 11;
        /* draw a table garants */
        foreach ($garants as $id => $garant)
        {
            if (!empty($garant[2])) {
                $loginColor = imagecolorallocate($img, $colors[$garant[2]]['red'], $colors[$garant[2]]['green'], $colors[$garant[2]]['blue']);
            } else if ($garant[2] == 'vip') {
                $loginColor = imagecolorallocate($img, $colors['guest']['red'], $colors['guest']['green'], $colors['guest']['blue']);
            }

            imagefttext($img, $fontSize, 0, 5,   $currentHeightLine + 13, $whiteColor, $fontPath, $id + 1 . '.');
            imagefttext($img, $fontSize, 0, 30,  $currentHeightLine + 13, $loginColor, $fontPath, $garant[0]);
            imagefttext($img, $fontSize, 0, 250, $currentHeightLine + 13, $whiteColor, $fontPath, $garant[1]);

            $currentHeightLine = $currentHeightLine + $lineHeight;
        }

        /* save image */
        $savePath = 'img/garants-online';
        imagepng($img, $savePath);

        /* destroy temporary resources */
        imagedestroy($img);

        /* dev render */
        echo "<img style='background: #000;' src='/" . $savePath . "'/>";
    }
