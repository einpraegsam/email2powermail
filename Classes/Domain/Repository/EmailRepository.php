<?php
namespace In2code\Email2powermail\Domain\Repository;

use In2code\Email2powermail\Domain\Model\Email;
use In2code\Email2powermail\Utility\MappingUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class EmailRepository
 */
class EmailRepository extends Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = [
        'email' => QueryInterface::ORDER_ASCENDING
    ];

    /**
     * @return array|QueryResultInterface
     */
    public function findAll()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $this->addConstraints($query);
        return $query->execute();
    }

    /**
     * @param string $identifier
     * @return Email
     */
    public function findByIdentifier($identifier)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('identifier', $identifier));
        $email = $query->execute()->getFirst();
        /** @var Email $email */
        return $email;
    }

    /**
     * @param QueryInterface $query
     */
    protected function addConstraints(QueryInterface $query)
    {
        $mapping = MappingUtility::getMappingConfiguration($this->objectType);
        if (is_array($mapping['in.'])) {
            $and = [];
            foreach ($mapping['in.'] as $fieldName => $value) {
                if (!empty($value)) {
                    $and[] = $query->in($fieldName, GeneralUtility::trimExplode(',', $value, true));
                }
            }
            $query->matching($query->logicalAnd($and));
        }
    }
}
