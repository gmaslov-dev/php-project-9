<?php

namespace Hexlet\Code\Repository;

interface RepositoryInterface
{
    public function getEntities();
    public function find(int $id);
    public function save(T $entity);
    public function update(T $entity);
    public function create(int $id);
}