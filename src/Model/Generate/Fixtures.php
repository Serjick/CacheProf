<?php

namespace Imhonet\CacheProf\Model\Generate;


use Faker\Generator as Faker;

class Fixtures implements \Iterator
{
    private $i = 0;

    /**
     * @var Labels
     */
    private $keys;

    /**
     * @var Faker
     */
    private $data;

    public function __construct(Labels $keys, Faker $data)
    {
        $this->keys = $keys;
        $this->data = $data;
    }

    private function getData()
    {
        $result = array();
        $ts = microtime(true);

        for ($i = $this->getLimit(); $i > 0; $i--) {
            $data = & $result[];
            $keys = $this->keys->current();
            $data[ $keys['label'] ] = $this->generate();
            $data[ $keys['stale'] ] = $ts;

            foreach ($keys['tags'] as $tag) {
                $data[$tag] = $ts;
            }

            unset($data);
            $this->keys->next();
        }

        return $result;
    }

    private function generate()
    {
        $rand = mt_rand(0, 100);

        if ($rand < 5) {
            $result = $this->generateUsers();
        } elseif ($rand < 30) {
            $result = $this->generateUser();
        } elseif ($rand < 95) {
            $result = $this->generateIds();
        } else {
            $result = $this->generateInt();
        }

        return $result;
    }

    private function generateUsers()
    {
        $result = array();

        for ($i = mt_rand(0, 10); $i > 0; $i--) {
            $result[] = $this->generateUser();
        }

        return $result;
    }

    private function generateUser()
    {
        return array(
            'id' => $this->data->randomNumber(),
            'login' => $this->data->userName,
            'password' => $this->data->md5,
            'name' => $this->data->firstName,
            'surname' => $this->data->lastName,
            'about' => $this->data->sentence(10),
            'email' => $this->data->safeEmail,
            'description' => $this->data->paragraph(10),
            'reg_date' => $this->data->unixTime,
            'address' => $this->data->address,
            'phone' => $this->data->phoneNumber,
            'ip' => $this->data->ipv4,
            'birthday' => $this->data->unixTime,
            'last_visit' => $this->data->unixTime,
            'created_at' => $this->data->unixTime,
        );
    }

    private function generateIds()
    {
        $result = array();

        for ($i = mt_rand(0, 100); $i > 0; $i--) {
            $result[] = $this->generateInt();
        }

        return $result;
    }

    private function generateInt()
    {
        return mt_rand(1, 50000000);
    }

    private function getLimit()
    {
        return floor(log10($this->i % 10 + 1) * 50 + 1);
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->getData();
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        ++$this->i;
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->i;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->i = 0;
        $this->keys->rewind();
    }
}
