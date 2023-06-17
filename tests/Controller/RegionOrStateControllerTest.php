<?php

namespace App\Test\Controller;

use App\Entity\RegionOrState;
use App\Repository\RegionOrStateRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegionOrStateControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RegionOrStateRepository $repository;
    private string $path = '/region/or/state/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(RegionOrState::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RegionOrState index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'region_or_state[name]' => 'Testing',
            'region_or_state[updateAt]' => 'Testing',
            'region_or_state[country]' => 'Testing',
        ]);

        self::assertResponseRedirects('/region/or/state/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new RegionOrState();
        $fixture->setName('My Title');
        $fixture->setUpdateAt('My Title');
        $fixture->setCountry('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RegionOrState');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new RegionOrState();
        $fixture->setName('My Title');
        $fixture->setUpdateAt('My Title');
        $fixture->setCountry('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'region_or_state[name]' => 'Something New',
            'region_or_state[updateAt]' => 'Something New',
            'region_or_state[country]' => 'Something New',
        ]);

        self::assertResponseRedirects('/region/or/state/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getUpdateAt());
        self::assertSame('Something New', $fixture[0]->getCountry());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new RegionOrState();
        $fixture->setName('My Title');
        $fixture->setUpdateAt('My Title');
        $fixture->setCountry('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/region/or/state/');
    }
}
