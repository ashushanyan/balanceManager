interface BalanceManagerInterface {
    public function deductBalance(UserInterface $user, string $amount): void;
    public function addBalance(UserInterface $user, string $amount): void;
    public function getBalance(UserInterface $user): string;
}

interface UserInterface {
    public function getBalance(): string;
    public function setBalance(string $balance): void;
}

class User implements UserInterface {
    private $balance;

    public function __construct(string $initialBalance) {
        $this->balance = $initialBalance;
    }

    public function getBalance(): string {
        return $this->balance;
    }

    public function setBalance(string $balance): void {
        $this->balance = $balance;
    }
}

class BalanceManager implements BalanceManagerInterface {
    public function deductBalance(UserInterface $user, string $amount): void {
        $newBalance = bcsub($user->getBalance(), $amount, 8);
        $user->setBalance($newBalance);
    }

    public function addBalance(UserInterface $user, string $amount): void {
        $newBalance = bcadd($user->getBalance(), $amount, 8);
        $user->setBalance($newBalance);
    }

    public function getBalance(UserInterface $user): string {
        return $user->getBalance();
    }
}

function simulateBalanceTransactions(User $user, BalanceManagerInterface $balanceManager, int $iterations) {
    for ($i = 0; $i < $iterations; $i++) {
        $randomAmount = number_format(rand(500, 1500) / 100, 8, '.', '');
        if (rand(0, 1)) {
            $balanceManager->addBalance($user, $randomAmount);
            echo "Added balance: " . $randomAmount . " | New Balance: " . $balanceManager->getBalance($user) . "\n";
        } else {
            $balanceManager->deductBalance($user, $randomAmount);
            echo "Deducted balance: " . $randomAmount . " | New Balance: " . $balanceManager->getBalance($user) . "\n";
        }
        usleep(10000);
    }
}

$user = new User('1000.12345678');
$balanceManager = new BalanceManager();
simulateBalanceTransactions($user, $balanceManager, 100);
