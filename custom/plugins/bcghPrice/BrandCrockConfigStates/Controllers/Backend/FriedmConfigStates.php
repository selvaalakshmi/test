<?php

class Shopware_Controllers_Backend_FriedmConfigStates extends Shopware_Controllers_Backend_ExtJs
{
    protected $manager = null;

    /**
     * enable script renderer and json request plugin
     *
     * @return void
     */
    public function init()
    {
        $this->View()->addTemplateDir(dirname(__FILE__) . '/../../Views/');
        parent::init();
    }

    /**
     * return status by group
     *
     * @throws Exception
     * @throws RuntimeException
     */
    public function readStatesAction()
    {
        $filter = $this->Request()->getParam('filter', null);
        $group = 'state';
        if ($filter && isset($filter[0])) {
            $group = $filter[0]['value'];
        }

        $query = $this->getOrderStatusQuery($group);
        $data = $this->setData($query->getArrayResult());
        $this->View()->assign(['success' => true, 'data' => $data]);
    }

    /**
     * sort status
     *
     * @throws RuntimeException
     */
    public function sortListAction()
    {
        $data = $this->Request()->getParam('data');
        $positions = json_decode($data);

        $builder = $this->getManager()->createQueryBuilder();
        $builder->update('Shopware\Models\Order\Status', 'status')
            ->where('status.id = :id');

        foreach ($positions as $position => $id) {
            $builder->set('status.position', $position)
                ->setParameter('id', $id)
                ->getQuery()
                ->execute();
        }
        $this->View()->assign(['success' => true]);
    }

    /**
     * update status
     *
     * @throws RuntimeException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws Exception
     */
    public function updateStatesAction()
    {
        $model = $this->getManager()->getRepository('Shopware\Models\Order\Status')->find($this->Request()->getParam('id'));
        if (!$model) {
            $this->View()->assign(['success' => false]);
        }
        $data = [
            'description' => $this->Request()->getParam('description'),
            'sendMail' => $this->Request()->getParam('sendMail'),
        ];
        $model->fromArray($data);
        $this->getManager()->persist($model);
        $this->getManager()->flush();
        $this->mkJsFile();
        $this->View()->assign(['success' => true]);
    }

    /**
     * create status
     *
     * @throws RuntimeException
     * @throws Zend_Db_Adapter_Exception
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws Exception
     */
    public function createStatesAction()
    {
        $id = $this->getNextID();
        $data = [
            'id' => $id,
            'name' => 'stateID' . $id,
            'description' => $this->Request()->getParam('description'),
            'position' => $this->Request()->getParam('position'),
            'group' => $this->Request()->getParam('groupType'),
            'mail' => $this->Request()->getParam('sendMail'),
        ];
        Shopware()->Db()->insert('s_core_states', $data);
        $this->mkJsFile();
        $this->View()->assign(['success' => true]);
    }

    /**
     * This class has its own OrderStatusQuery as we need to get rid of states with satus.id = -1
     *
     * @param       $group
     * @param array $orderBy
     *
     * @return \Doctrine\ORM\Query
     * @throws RuntimeException
     */
    public function getOrderStatusQuery($group, $orderBy = [['property' => 'status.position', 'direction' => 'ASC']])
    {
        $builder = $this->getManager()->createQueryBuilder();
        $builder->select(['status'])
            ->from('Shopware\Models\Order\Status', 'status')
            ->andWhere('status.group = :group')
            ->addOrderBy($orderBy)
            ->setParameter('group', $group);

        return $builder->getQuery();
    }

    /**
     * Shopware_Controllers_Backend_FriedmConfigStates::mkJsFile()
     *
     * @throws Exception
     */
    private function mkJsFile()
    {
        /** @var \Shopware_Plugins_Backend_FriedmConfigStates_Bootstrap $plugin */
        $plugin = $this->get('plugins')->Backend()->FriedmConfigStates();
        $plugin->mkJsFile();
    }

    /**
     * Internal helper function to get access to the entity manager.
     *
     * @return Shopware\Components\Model\ModelManager
     * @throws RuntimeException
     */
    public function getManager()
    {
        if ($this->manager === null) {
            $this->manager = Shopware()->Models();
        }

        return $this->manager;
    }

    /**
     * Helper function to get next ID
     *
     * @return array
     * @throws RuntimeException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNextID()
    {
        $builder = $this->getManager()->createQueryBuilder();
        $builder->select(['status'])
            ->from('Shopware\Models\Order\Status', 'status')
            ->addOrderBy([['property' => 'status.id', 'direction' => 'DESC']])
            ->setMaxResults(1);
        $data = $builder->getQuery()->getOneOrNullResult();

        return $data->getId() + 1;
    }

    /**
     * Helper function to unset(group)
     *
     * @param array $data
     *
     * @return array
     * @throws Exception
     */
    public function setData($data)
    {
        foreach ($data as $dK => $dV) {
            $dV['groupType'] = $dV['group'];
            $dV['namespace'] = $dV['group'] == 'payment' ? 'backend/static/payment_status' : 'backend/static/order_status';
            $dV['description'] = $this->getSnippet($dV['namespace'], $dV['name']);
            unset($dV['group']);
            $data[$dK] = $dV;
        }

        return $data;
    }

    /**
     * helper to get snippet
     *
     * @param string   $namespace
     * @param string   $name
     * @param string   $default
     * @param int|null $localeID
     *
     * @return mixed
     * @throws Exception
     */
    public function getSnippet($namespace, $name, $default = '', $localeID = null)
    {
        try {
            /** @var \Shopware_Components_Snippet_Manager $snippet */
            $snippet = $this->get('snippets');
            if ($localeID) {
                /** @var \Shopware\Models\Shop\Locale $locale */
                $locale = $this->get('models')->getRepository('Shopware\Models\Shop\Locale')->find($localeID);
                $snippet->setLocale($locale);
            }
            $namespace = $snippet->getNamespace($namespace);
            $value = $namespace->get($name, $default, true);
        } catch (\Exception $e) {
            $value = '';
        }

        return $value;
    }
}
