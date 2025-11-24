<?php

namespace Dynamic\Elements\Tabset\Element;

use Override;
use SilverStripe\Forms\FieldList;
use DNADesign\ElementalList\Model\ElementList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;

/**
 * Class ElementTabSet
 * @package Dynamic\Elements\Tabset\Element
 */
class ElementTabSet extends ElementList
{
    private static string $cms_icon_class = 'font-icon-block-layout';

    private static string $table_name = "ElementTabSet";

    private static string $singular_name = 'Tabset';

    private static string $plural_name = 'Tabsets';

    /**
     * Set to false to prevent an in-line edit form from showing in an elemental area. Instead the element will be
     * clickable and a GridFieldDetailForm will be used.
     *
     * @config
     */
    private static bool $inline_editable = false;

    #[Override]
    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'FileTracking',
            'LinkTracking'
        ]);

        return $fields;
    }

    /**
     * @return DBHTMLText
     */
    #[Override]
    public function getSummary(): string
    {
        if (!$this->Elements()) {
            return '';
        }

        $ct = $this->Elements()->Elements()->count();

        if ($ct == 1) {
            $label = ' tab';
        } else {
            $label = ' tabs';
        }

        return DBField::create_field(
            'HTMLText',
            $ct . $label
        )->Summary(20);
    }

    #[Override]
    protected function provideBlockSchema(): array
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();

        return $blockSchema;
    }

    #[Override]
    public function getType(): string
    {
        return _t(self::class . '.BlockType', 'TabSet');
    }
}
