<?php

class Animal {
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function talk() {
        return '?';
    }

    public function eats() {
        return '?';
    }

    public function barks() {
        return false;
    }
}

class Cat extends Animal {
    public function talk() {
        return 'Miauw';
    }

    public function eats() {
        return 'vlees/vis';
    }
}

class Dog extends Animal {
    public function talk() {
        return 'Woef';
    }

    public function eats() {
        return 'vlees';
    }

    public function barks() {
        return true;
    }
}

class Poedel extends Dog {
    public function talk() {
        return 'Waf';
    }
}

$animals = [
    'Ollie' => new Cat('Ollie'),
    'Nola' => new Dog('Nola'),
    'Gratje' => new Poedel('Gratje')
];

$selectedAnimal = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['animal'] ?? '';

    if (is_string($name) && isset($animals[$name])) {
        $selectedAnimal = $animals[$name];
    }
}

?>

<h2>Kies een dierennaam</h2>

<form method="post">
    <?php foreach ($animals as $animal): ?>
        <button
            type="submit"
            name="animal"
            value="<?php echo htmlspecialchars($animal->name); ?>"
        >
            <?php echo htmlspecialchars($animal->name); ?>
        </button>
    <?php endforeach; ?>
</form>

<?php if ($selectedAnimal !== null): ?>
    <h3><?php echo htmlspecialchars($selectedAnimal->name); ?></h3>

    <p>Zegt: <?php echo htmlspecialchars($selectedAnimal->talk()); ?></p>
    <p>Eet: <?php echo htmlspecialchars($selectedAnimal->eats()); ?></p>
    <p>Blaft: <?php echo $selectedAnimal->barks() ? 'ja' : 'nee'; ?></p>
<?php endif; ?>