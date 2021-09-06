<?php


namespace Pyz\Zed\ContactUs\Communication\Table;


use Orm\Zed\ContactUs\Persistence\Map\PyzContactUsTableMap;
use Orm\Zed\ContactUs\Persistence\PyzContactUs;
use Propel\Runtime\Collection\ObjectCollection;
use Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainerInterface;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class ContactUsTable extends AbstractTable
{
    public const ACTIONS = 'actions';

    public const COL_ID_CONTACT_US = 'id_contact_us';
    public const COL_NAME = 'name';
    public const COL_MESSAGE = 'message';
    /**
     * @var ContactUsQueryContainerInterface
     */
    protected $contactUsQueryContainer;

    /**
     * ContactUsTable constructor.
     *
     * @param ContactUsQueryContainerInterface $contactUsQueryContainer
     */
    public function __construct(ContactUsQueryContainerInterface $contactUsQueryContainer)
    {
        $this->contactUsQueryContainer = $contactUsQueryContainer;
    }

    /**
     * @param TableConfiguration $config
     *
     * @return TableConfiguration
     */
    protected function configure(TableConfiguration $config)
    {
        $config->setHeader([
            static::COL_ID_CONTACT_US => "#",
            static::COL_NAME => "Name",
            static::COL_MESSAGE => "Message",
            static::ACTIONS => self::ACTIONS,
        ]);
        $config->addRawColumn(self::ACTIONS);
        $config->setSortable([
            static::COL_ID_CONTACT_US,
            static::COL_NAME,
            static::COL_MESSAGE,
        ]);
        $config->setSearchable([
            PyzContactUsTableMap::COL_NAME,
            PyzContactUsTableMap::COL_MESSAGE,
        ]);

        return $config;
    }

    /**
     * @param TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config)
    {
        $query = $this->prepareQuery();
        /**
         * @var PyzContactUs[] $contactCollection
         */
        $contactCollection = $this->runQuery($query, $config, true);
        if($contactCollection->count() < 1){
            return [];
        }

        return $this->mapContactCollection($contactCollection);
    }

    /**
     * @param ObjectCollection $contactCollection
     *
     * @return array
     */
    protected function mapContactCollection(ObjectCollection $contactCollection)
    {
        $contactList= [];

        foreach ($contactCollection as $contactEntity)
        {
            $contactList[] = $this->mapContactRow($contactEntity);
        }

        return $contactList;
    }

    /**
     * @param PyzContactUs $contactEntity
     *
     * @return array|string
     */
    protected function mapContactRow(PyzContactUs $contactEntity)
    {
        $contactRow = $contactEntity->toArray();
        $contactRow[static::COL_ID_CONTACT_US] = $contactEntity->getIdContactUs();
        $contactRow[static::COL_NAME] = $contactEntity->getName();
        $contactRow[static::COL_MESSAGE] = $contactEntity->getMessage();

        $contactRow[static::ACTIONS] = $this->buildLinks($contactEntity);

        return $contactRow;
    }

    /**
     * @param PyzContactUs $contact
     *
     * @return string
     */
    protected function buildLinks(PyzContactUs $contact)
    {
        $buttons = [];
        $buttons[] = $this->generateViewButton(
            sprintf('/contact-us/view?id-contact-us=%d', $contact->getIdContactUs()), "View"
        );

        return implode('', $buttons);
    }

    /**
     * @return \Orm\Zed\ContactUs\Persistence\PyzContactUsQuery
     */
    protected function prepareQuery()
    {
        $query = $this->contactUsQueryContainer->queryContacts();

        return $query;
    }
}
