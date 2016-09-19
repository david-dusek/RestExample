<?php
/**
 * @param string $class
 */
spl_autoload_register(function ($class) {
  $prefix = 'RestExample\\';
  $classPrefixLength = strlen($prefix);

  if (strncmp($prefix, $class, $classPrefixLength) !== 0) {
    return;
  }

  $relativeClass = substr($class, $classPrefixLength);
  $baseDirectory = __DIR__ . '/src/';
  $classFile = $baseDirectory . str_replace('\\', '/', $relativeClass) . '.php';

  if (file_exists($classFile)) {
    require $classFile;
  }
});
