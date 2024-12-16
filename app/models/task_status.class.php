<?php
declare(strict_types=1);

enum TaskStatus : string {
    case PIPELINED = 'PIPELINED';
    case INIT = 'INIT';
    case DELIVERED = 'DELIVERED';
    case RELEASED = 'RELEASED';
}
?>