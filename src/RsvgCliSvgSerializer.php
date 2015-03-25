<?php

namespace Krak\Svg;

class RsvgCliSvgSerializer implements SvgSerializer
{
    const PNG = 'png';
    const PDF = 'pdf';
    const PS = 'ps';

    private $serializer;
    private $type;

    public function __construct(SvgSerializer $serializer, $type = self::PNG)
    {
        $this->serializer = $serializer;
        $this->type = $type;
    }

    public function serializeSvg(Element\Svg $svg)
    {
        $svg_data = $this->serializer->serializeSvg($svg);
        $fmt = 'rsvg-convert --format=%s';
        return $this->pipeCommand($svg_data, sprintf($fmt, $this->type));
    }

    private function pipeCommand($data, $cmd)
    {
        $descriptorspec = array(
           0 => array("pipe", "r"),
           1 => array("pipe", "w")
        );

        $pipes = [];
        $process = proc_open($cmd, $descriptorspec, $pipes);

        if (!is_resource($process)) {
            $this->logger->debug('process was not a resource...');
            return '';
        }

        fwrite($pipes[0], $data);
        fclose($pipes[0]);

        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        return $output;
    }
}
