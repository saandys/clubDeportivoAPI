<?

namespace Src\Infrastructure;

use Src\Domain\Repositories\IUserRepository;

final class User2EloquentRepository
{
    public function store(string $name, string $email, string $password): void
    {
        // Lógica para almacenar el usuario
    }
}
