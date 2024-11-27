<?php

// Component interface
interface FileSystemComponent {
    public function getName(): string;
    public function getSize(): int;
    public function displayInfo(): string;
}

// Leaf class for File
class File implements FileSystemComponent {
    private string $name;
    private int $size; // Size in bytes

    public function __construct(string $name, int $size) {
        $this->name = $name;
        $this->size = $size;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getSize(): int {
        return $this->size;
    }

    public function displayInfo(): string {
        return "File: {$this->name}, Size: {$this->size} bytes";
    }
}

// Composite class for Directory
class Directory implements FileSystemComponent {
    private string $name;
    private array $children = [];

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function add(FileSystemComponent $component): void {
        $this->children[] = $component;
    }

    public function remove(FileSystemComponent $component): void {
        foreach ($this->children as $key => $child) {
            if ($child === $component) {
                unset($this->children[$key]);
                break;
            }
        }
    }

    public function getName(): string {
        return $this->name;
    }

    public function getSize(): int {
        $totalSize = 0;
        foreach ($this->children as $child) {
            $totalSize += $child->getSize();
        }
        return $totalSize;
    }

    public function displayInfo(): string {
        $info = "Directory: {$this->name}\n";
        foreach ($this->children as $child) {
            $info .= "  - " . $child->displayInfo() . "\n";
        }
        return $info;
    }
}

// Client code to test the composite pattern
function clientCode() {
    // Create files
    $file1 = new File("file1.txt", 500);
    $file2 = new File("file2.jpg", 1500);
    $file3 = new File("file3.docx", 700);

    // Create directories
    $directory1 = new Directory("Documents");
    $directory2 = new Directory("Images");

    // Add files to directories
    $directory1->add($file1);
    $directory1->add($file3);
    $directory2->add($file2);

    // Create root directory
    $rootDirectory = new Directory("Root");
    $rootDirectory->add($directory1);
    $rootDirectory->add($directory2);

    // Display information
    echo $rootDirectory->displayInfo();
    echo "Total size of root directory: " . $rootDirectory->getSize() . " bytes\n";
}

// Run the client code
clientCode();
