<?php

namespace Model;

interface SchoolComponent
{
    /**
     * @return array
     */
    public function formatForPrint(): array;

    /**
     * @return string
     */
    public function toString(): string;
}