<?php

// Strategy interface
interface SortStrategy {
    public function sort(array &$words);
}

// Strategy: Alphabetical sort
class AlphabeticalSort implements SortStrategy {
    public function sort(array &$words) {
        sort($words);
    }
}

// Strategy: Length sort
class LengthSort implements SortStrategy {
    public function sort(array &$words) {
        usort($words, function ($a, $b) {
            if (strlen($a) == strlen($b)) {
                return strcmp($a, $b); // Sort alphabetically if lengths are equal
            }
            return strlen($a) <=> strlen($b); // Sort by length
        });
    }
}

class WordSorter {
    private $strategy;

    public function setStrategy(SortStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function sortWords(array &$words) {
        $this->strategy->sort($words);
    }
}

// Test code
$words = ["banana", "apple", "grape", "kiwi", "blueberry", "pear", "peach", "melon"];
$sorter = new WordSorter();

// Sort alphabetically
$alphabeticalSort = new AlphabeticalSort();
$sorter->setStrategy($alphabeticalSort);
$sorter->sortWords($words);
echo "Sorted alphabetically:\n";
echo implode(" ", $words) . "\n";

// Sort by length
$lengthSort = new LengthSort();
$sorter->setStrategy($lengthSort);
$sorter->sortWords($words);
echo "Sorted by length:\n";
echo implode(" ", $words) . "\n";
