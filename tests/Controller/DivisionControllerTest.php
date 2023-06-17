<?php

namespace App\Test\Controller;

use App\Entity\Division;
use App\Repository\DivisionRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DivisionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private DivisionRepository $repository;
    private string $path = '/division/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Division::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Division index');

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
            'division[name]' => 'Testing',
            'division[description]' => 'Testing',
            'division[updateAt]' => 'Testing',
            'division[regionOrState]' => 'Testing',
        ]);

        self::assertResponseRedirects('/division/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Division();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setUpdateAt('My Title');
        $fixture->setRegionOrState('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Division');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Division();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setUpdateAt('My Title');
        $fixture->setRegionOrState('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'division[name]' => 'Something New',
            'division[description]' => 'Something New',
            'division[updateAt]' => 'Something New',
            'division[regionOrState]' => 'Something New',
        ]);

        self::assertResponseRedirects('/division/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getUpdateAt());
        self::assertSame('Something New', $fixture[0]->getRegionOrState());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Division();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setUpdateAt('My Title');
        $fixture->setRegionOrState('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/division/');
    }
}
