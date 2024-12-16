<?php
declare(strict_types=1);

enum TaskKind : string {
    case FRONTOFFICE = 'FRONTOFFICE';
    case BACKOFFICE = 'BACKOFFICE';
    case DATABASE = 'DATABASE';
}
?>