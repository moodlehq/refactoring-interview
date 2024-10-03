<?php

interface RepositoryInterface {
    
    public function printHelp();

    public function printAll();   

    public function create($dataArray);  

    public function update($id, $dataArray);  

    public function delete($id);  
    
    // Optional custom method handling, defaults to null
    public function handleCustomOption($option);
}
