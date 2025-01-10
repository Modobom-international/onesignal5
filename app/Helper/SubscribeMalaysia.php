<?php


namespace App\Helper;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;
use Facebook\WebDriver\WebDriverExpectedCondition;

class SubscribeMalaysia
{
    /**
     * Subscribe Umobile
     *
     * @param $url
     * @param $otp
     * @param null $userAgent
     * @throws \Facebook\WebDriver\Exception\UnknownErrorException
     */
    public static function subscribeUmobile($url, $otp, $userAgent = null)
    {
        ///https://partner.u.com.my/partner/#/c/cpsPs7o
        /// 2855
        ///
        ///

        // the URL to the local Selenium Server
        //$host = 'http://localhost:4444/';
        //$host = 'http://192.168.1.6:4444';
        $host = env('WEBDRIVER_HOST');
        if (empty($host)) {
            $host = 'http://localhost:4444/';
        }

        // to control a Chrome instance
        $capabilities = DesiredCapabilities::chrome();

        // define the browser options
        $chromeOptions = new ChromeOptions();
        // to run Chrome in headless mode
        $chromeOptions->addArguments(['--no-proxy-server']); // <- comment out for testing
        $chromeOptions->addArguments(['--headless']); // <- comment out for testing
        $chromeOptions->addArguments(['--disable-dev-shm-usage']); // <- comment out for testing
        $chromeOptions->addArguments(['--no-sandbox']); // <- comment out for testing
        $chromeOptions->addArguments(['--disable-extensions']); // <- comment out for testing

        //$customUserAgent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/114.0.5735.99 Mobile/15E148 Safari/604.1';
        $customUserAgent = 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G955U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Mobile Safari/537.36';
        if (!empty($userAgent)) {
            $customUserAgent = $userAgent;
        }

        $chromeOptions->addArguments([
            "--user-agent=$customUserAgent"
            // other options...
        ]);


        // register the Chrome options
        $capabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $chromeOptions);

        // initialize a driver to control a Chrome instance
        $driver = RemoteWebDriver::create($host, $capabilities);

        // maximize the window to avoid responsive rendering
        //$driver->manage()->window()->maximize();
        $driver->manage()->window()->setSize(new WebDriverDimension(430, 932)); //iphone

        // open the target page in a new tab

        $driver->get($url);

        $fileDirPath = storage_path('logs/malaysia/'.Common::getCurrentVNTime('Y/m/d').'/'.$otp);
        if (!is_dir($fileDirPath)) {
            mkdir($fileDirPath, 0777, true);
        }

        $pathDatetime = Common::getCurrentVNTime('His').'_'.$otp;


        //wait for visible input PIN
        try {
            $driver->wait(10)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('input[type=text]'))
            );

            //save html
            $htmlFirst = $fileDirPath.'/'.$pathDatetime.'_first.html';
            self::saveSource($htmlFirst, $driver->getPageSource());


        } catch (\Exception $ex) {
            dump('Error: '.$ex);

            //screenshot after fill PIN + submit
            $screenshotFilePath = $fileDirPath.'/'.$pathDatetime.'_first_error.png';
            $driver->takeScreenshot($screenshotFilePath);

            //save html
            $htmlErrorFirst = $fileDirPath.'/'.$pathDatetime.'_first_error.html';
            self::saveSource($htmlErrorFirst, $driver->getPageSource());

            \Log::channel('malaysia')->error($ex);

            $driver->close();
            exit;
        }

        //Fill pin and submit
        $driver->findElement(WebDriverBy::tagName('input')) // find search input element
        ->sendKeys($otp) // fill the search box
        ->submit(); // submit the whole form


/*
        //fill PIN and submit
        $script = <<<EOD
document.getElementById('smsVerifCode').value = $otp;
EOD;
        $driver->executeScript($script);
        sleep(1);

        //screenshot after fill PIN
        $screenshotFilePath = $fileDirPath.'/'.$pathDatetime.'_after_fill_pin.png';
        $driver->takeScreenshot($screenshotFilePath);

        $script = <<<EOD
document.querySelector('button[type=submit]').click();
EOD;

        $driver->executeScript($script);

*/

        //screenshot after fill PIN + submit
        $screenshotFilePath = $fileDirPath.'/'.$pathDatetime.'_after_submit.png';
        $driver->takeScreenshot($screenshotFilePath);

        //save html
        $htmlAfterSubmit = $fileDirPath.'/'.$pathDatetime.'_after_submit.html';
        self::saveSource($htmlAfterSubmit, $driver->getPageSource());

        //delay about 5s and screenshot result
        sleep(3);
        $screenshotResultFilePath = $fileDirPath.'/'.$pathDatetime.'_result1.png';
        $driver->takeScreenshot($screenshotResultFilePath);

        //save html
        $htmlResult = $fileDirPath.'/'.$pathDatetime.'_result1.html';
        self::saveSource($htmlResult, $driver->getPageSource());

        try {
            $driver->wait(10)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector(".customerconsent-components-resultpage-index-successPage"))
            );

            $screenshotResultFilePath = $fileDirPath.'/'.$pathDatetime.'_result2.png';
            $driver->takeScreenshot($screenshotResultFilePath);

            //save html
            $htmlResult = $fileDirPath.'/'.$pathDatetime.'_result2.html';
            self::saveSource($htmlResult, $driver->getPageSource());

        } catch (\Exception $ex) {
            dump('Error: '.$ex);

            $screenshotResultFilePath = $fileDirPath.'/'.$pathDatetime.'_result_failed.png';
            $driver->takeScreenshot($screenshotResultFilePath);


            //save html
            $htmlResult = $fileDirPath.'/'.$pathDatetime.'_result_failed.html';
            self::saveSource($htmlResult, $driver->getPageSource());

            \Log::channel('malaysia')->error($ex);

            $driver->close();
            exit;
        }

        //sleep(30);


// close the driver and release its resources
        $driver->close();


    }

    private static function saveSource($filePath, $html)
    {
        file_put_contents($filePath, $html);
    }

    public static function takeFullScreenshot($driver, $screenshot_name)
    {
        $total_width = $driver->executeScript('return Math.max.apply(null, [document.body.clientWidth, document.body.scrollWidth, document.documentElement.scrollWidth, document.documentElement.clientWidth])');
        $total_height = $driver->executeScript('return Math.max.apply(null, [document.body.clientHeight, document.body.scrollHeight, document.documentElement.scrollHeight, document.documentElement.clientHeight])');

        $viewport_width = $driver->executeScript('return document.documentElement.clientWidth');
        $viewport_height = $driver->executeScript('return document.documentElement.clientHeight');

        $driver->executeScript('window.scrollTo(0, 0)');

        $full_capture = imagecreatetruecolor($total_width, $total_height);

        $repeat_x = ceil($total_width / $viewport_width);
        $repeat_y = ceil($total_height / $viewport_height);

        for ($x = 0; $x < $repeat_x; $x++) {
            $x_pos = $x * $viewport_width;

            $before_top = -1;
            for ($y = 0; $y < $repeat_y; $y++) {
                $y_pos = $y * $viewport_height;
                $driver->executeScript("window.scrollTo({$x_pos}, {$y_pos})");

                $scroll_left = $driver->executeScript("return window.pageXOffset");
                $scroll_top = $driver->executeScript("return window.pageYOffset");
                if ($before_top == $scroll_top) {
                    break;
                }

                $tmp_name = "{$screenshot_name}.tmp";
                $driver->takeScreenshot($tmp_name);
                if (!file_exists($tmp_name)) {
                    throw new Exception('Could not save screenshot');
                }

                $tmp_image = imagecreatefrompng($tmp_name);
                imagecopy($full_capture, $tmp_image, $scroll_left, $scroll_top, 0, 0, $viewport_width, $viewport_height);
                imagedestroy($tmp_image);
                unlink($tmp_name);

                $before_top = $scroll_top;
            }
        }

        imagepng($full_capture, $screenshot_name);
        imagedestroy($full_capture);
    }

}
