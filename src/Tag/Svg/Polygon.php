<?php

namespace Spipu\Html2Pdf\Tag\Svg;

use Spipu\Html2Pdf\Exception\HtmlParsingException;
use Spipu\Html2Pdf\Parsing\Node;

/**
 * Class Polygon
 */
class Polygon extends SvgTag
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'polygon';
    }

    /**
     * {@inheritDoc}
     */
    public function open(Node $node)
    {
        if (!$this->svgDrawer->isInDraw()) {
            $e = new HtmlParsingException('The asked [POLYGON] tag is not in a [DRAW] tag');
            $e->setInvalidTag('POLYGON');
            throw $e;
        }

        $params = $node->getParams();

        $this->pdf->doTransform(isset($params['transform']) ? $this->svgDrawer->prepareTransform($params['transform']) : null);
        $this->parsingCss->save();
        $styles = $this->parsingCss->getSvgStyle('path', $params);
        $this->svgDrawer->polygon($params, $styles);

        $this->pdf->undoTransform();
        $this->parsingCss->load();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function close(Node $node)
    {
        return true;
    }
}
