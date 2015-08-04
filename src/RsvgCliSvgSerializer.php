<?php

namespace Krak\Svg;

class RsvgCliSvgSerializer implements SvgSerializer
{
    const PNG = 'png';
    const PDF = 'pdf';
    const PS = 'ps';

    private $serializer;
    private $type;

    public function __construct($serializer, $type = self::PNG)
    {
        $this->serializer = $serializer;
        $this->type = $type;
    }

    public function serializeSvg(Element\Svg $svg)
    {
        $svg_data = serialize_svg($this->serializer, $svg);
        $fmt = 'rsvg-convert --format=%s';
        return $this->pipeCommand($svg_data, sprintf($fmt, $this->type));
    }

    private function pipeCommand($data, $cmd)
    {
        $pipes = [];
        $process = proc_open($cmd, [["pipe", "r"],["pipe", "w"],], $pipes);

        if (!is_resource($process)) {
            return '';
        }

        fwrite($pipes[0], $data);
        fclose($pipes[0]);

        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        return $output;
    }
}
