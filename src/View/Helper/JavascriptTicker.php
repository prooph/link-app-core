<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 3/22/15 - 9:40 PM
 */
namespace Prooph\Link\Application\View\Helper;

use Prooph\Link\Application\Projection\ProcessingConfig;
use Zend\View\Helper\AbstractHelper;

/**
 * Class JavascriptTicker
 *
 * This view helper provides a snippet to start a javascript ticker for the application.
 * It reads configuration from the processing config and set up the ticker accordingly.
 *
 * @package Prooph\Link\Application\View\Helper
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class JavascriptTicker extends AbstractHelper
{
    /**
     * @var ProcessingConfig
     */
    private $systemConfig;

    /**
     * @param ProcessingConfig $config
     */
    public function __construct(ProcessingConfig $config)
    {
        $this->systemConfig = $config;
    }

    public function __invoke()
    {
        if ($this->systemConfig->isJavascriptTickerEnabled()) {
            $interval = $this->systemConfig->getJavascriptTickerInterval();
            $workerUrl = $this->getView()->basePath() . '/js/prooph/link/app/processing.ticker.js';
            $tickUrl = $this->getView()->url('prooph.link/tick');

$js = <<<JS
<script type="text/javascript">
if (typeof(Worker) === "undefined") {
    $.appErrorNotify('Web Workers are not supported by the browser. You can not use the Javascript ticker!');
} else {
    var tickerWorker = new Worker ("{$workerUrl}");

    tickerWorker.addEventListener("message", function(msg) {
        if (msg.data.xhr.readyState == 1) {
            console.log("xhr changed");
            $("#js_ticker_status").addClass('text-info').removeClass('text-error');
        }else if (msg.data.xhr.readyState == 4) {
            console.log("xhr finished");
            if (msg.data.xhr.status != 200) {
                $.appErrorNotify("[Tikcer Error] " + msg.data.xhr.responseText);
                $("#js_ticker_status").addClass('text-error').removeClass('text-info');
            } else {
                $("#js_ticker_status").removeClass('text-error').removeClass('text-info');
            }
        }
    }, true);

    tickerWorker.addEventListener("error", function(error) {
        $.appErrorNotify("Ticker error: " + ['Line ', error.lineno, ' in ', error.filename, ': ', error.message].join(''));
        if (window.console) {
            console.log("Ticker error: ", error);
        }
    }, true);

    tickerWorker.postMessage({interval : $interval, url : '{$tickUrl}'});
}
</script>
JS;
        } else {
            $js = "<script type=\"text/javascript\">$('#js_ticker_status').addClass('text-hide')</script>";
        }
        return $js;
    }
}
