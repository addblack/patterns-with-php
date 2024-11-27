<?php 

class TVShow {
    private string $name;
    private string $time;

    public function __construct(string $name, string $time) {
        $this->name = $name;
        $this->time = $time;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getTime(): string {
        return $this->time;
    }
}

interface TVShowIterator {
    public function hasNext(): bool;
    public function next(): TVShow;
}

interface TVShowAggregate {
    public function createEnumerator(): TVShowIterator;
}

class TVProgram implements TVShowAggregate {
    private array $shows = [];

    public function addShow(TVShow $show) {
        $this->shows[] = $show;
    }

    public function createEnumerator(): TVShowIterator {
        return new AllShowsIterator($this);
    }

    public function createEveningEnumerator(): TVShowIterator {
        return new EveningShowsIterator($this);
    }

    public function getShows(): array {
        return $this->shows;
    }
}

// Concrete Iterator for all shows
class AllShowsIterator implements TVShowIterator {
    private TVProgram $tvProgram;
    private int $current = 0;

    public function __construct(TVProgram $tvProgram) {
        $this->tvProgram = $tvProgram;
    }

    public function hasNext(): bool {
        return $this->current < count($this->tvProgram->getShows());
    }

    public function next(): TVShow {
        return $this->tvProgram->getShows()[$this->current++];
    }
}

// Concrete Iterator for evening shows
class EveningShowsIterator implements TVShowIterator {
    private TVProgram $tvProgram;
    private int $current = 0;
    private array $eveningShows;

    public function __construct(TVProgram $tvProgram) {
        $this->tvProgram = $tvProgram;
        $this->eveningShows = array_filter(
            $tvProgram->getShows(),
            fn($show) => substr($show->getTime(), 0, 2) >= '18' // Filter evening shows (after 18:00)
        );
    }

    public function hasNext(): bool {
        return $this->current < count($this->eveningShows);
    }

    public function next(): TVShow {
        return $this->eveningShows[$this->current++];
    }
}

// Viewer class
class Viewer {
    public function viewAllShows(TVProgram $tvProgram) {
        $iterator = $tvProgram->createEnumerator();
        echo "All TV Shows:\n";
        while ($iterator->hasNext()) {
            $show = $iterator->next();
            echo "{$show->getName()} at {$show->getTime()}\n";
        }
    }

    public function viewEveningShows(TVProgram $tvProgram) {
        $iterator = $tvProgram->createEveningEnumerator();
        echo "\nEvening TV Shows:\n";
        while ($iterator->hasNext()) {
            $show = $iterator->next();
            echo "{$show->getName()} at {$show->getTime()}\n";
        }
    }
}

$tvProgram = new TVProgram();
$tvProgram->addShow(new TVShow("Morning News", "09:00"));
$tvProgram->addShow(new TVShow("Cooking Show", "14:00"));
$tvProgram->addShow(new TVShow("Evening Movie", "20:00"));
$tvProgram->addShow(new TVShow("Late Night Talk Show", "23:00"));

$viewer = new Viewer();
$viewer->viewAllShows($tvProgram);
$viewer->viewEveningShows($tvProgram);

?>
