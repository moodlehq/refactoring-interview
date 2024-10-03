<?php

class CommandHandler {
    private $repository;
    
    public function __construct(RepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function handle($options, $argv) {
        if (isset($options['h']) || isset($options['help'])) { //var_dump($options); print_r($argv);
            $this->repository->printHelp();
        } elseif (isset($options['a']) || isset($options['all'])) {
            $this->repository->printAll();
        } elseif (isset($options['c']) || isset($options['create'])) {
            $args = $this->extractArgs($options, $argv); //print_r($args);exit;
            $this->repository->create($args);
        } elseif (isset($options['u']) || isset($options['update'])) {
            //print_r($options); print_r($argv);
            $id = isset($options['u']) ? $options['u'] : (isset($options['update']) ? $options['update'] : null);
            if (!$id) {
                throw new InvalidArgumentException("ID is required to update!");
            }
            if(!is_numeric($id)) {
                throw new InvalidArgumentException("ID is not numeric!");
            }
            $args = $this->extractArgs($options, $argv); //print_r($args);exit;
            array_shift($args);
            $this->repository->update((int)$id, $args);
        } elseif (isset($options['d']) || isset($options['delete'])) {
            $id = isset($options['d']) ? $options['d'] : (isset($options['delete']) ? $options['delete'] : null);
            if (!$id) {
                throw new InvalidArgumentException("ID is required to delete!");
            }
            $this->repository->delete((int)$id);
        } else {
            array_shift($argv); 
            $this->repository->handleCustomOption($options, $argv);
        }
    }

    protected function extractArgs($options, $argv) {
        // Remove the script name and any options from $argv to get positional args
        array_shift($argv);
        foreach ($options as $optKey => $optValue) {
            $keyPos = array_search("-$optKey", $argv);
            if ($keyPos !== false) {
                unset($argv[$keyPos]);  // Remove the option from args list
            }
        }
        return array_values($argv);
    }
}
