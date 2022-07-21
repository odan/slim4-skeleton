<?php

fwrite(STDERR, 'APP_ENV: ' . ($_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? '?'));
