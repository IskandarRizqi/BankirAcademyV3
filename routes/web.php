<?php

/*
|--------------------------------------------------------------------------
| Web Route Loader
|--------------------------------------------------------------------------
|
| Browser routes are split by application boundary. Keep the require order
| stable because some legacy routes use overlapping URI patterns.
|
*/

require __DIR__.'/web/admin.php';
require __DIR__.'/web/compact.php';
require __DIR__.'/web/transactions.php';
require __DIR__.'/web/auth.php';
require __DIR__.'/web/public.php';
require __DIR__.'/web/member-non-anggota.php';
