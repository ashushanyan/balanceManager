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

$user = new User('1000.12345678');

$balanceManager = new BalanceManager();
$balanceManager->addBalance($user, '50.12345678');
echo "Balance after crediting: " . $balanceManager->getBalance($user) . "\n";

$balanceManager->deductBalance($user, '100.12345678');
echo "Balance after deduction: " . $balanceManager->getBalance($user);
