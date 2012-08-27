<?php

/*
 * This code is distributed under the terms of the WTFPL. http://sam.zoy.org/wtfpl/
 *
 * This may be considered to be trivial and so not subject to copyright. If this
 * code is found to be non-trivial the WTFPL applies.
 */

/*
 * Include the config variables.
 */

require_once(__DIR__ . '/config.php');

$branch = $_GET['branch'];

if (!$branch) {
  die('You must specify a branch');
}

$cmd = 'cd ' . REPO_PATH . ' && ' . GIT_CMD . ' diff ' . escapeshellarg(MASTER_BRANCH . '...' . $branch);

function render_output($out) {

  if (!count($out)) {
    return 'No changes';
  }

  $markup = "<ul>\n";
  foreach ($out as $line) {
    if ('diff --git' == substr($line, 0, 10)) {
      $markup .= <<<HTML
      </ul>
      <h2>$line</h2>
      <ul>

HTML;
      continue;
    }

    $first_char = substr($line, 0, 1);
    $class = '';
    if ('+' == $first_char) {
      $class = ' class="add"';
    }
    elseif ('-' == $first_char) {
      $class = ' class="subtract"';
    }

    $markup .= "<li$class>$line</li>\n";
  }
  $markup .= "</ul>\n";

  return $markup;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Branch Diff</title>
  <style type="text/css">

    body {
      font-family: sans-serif;
    }

    #diff ul {
      font-family: monospace;
      white-space: nowrap;
    }

    ul, li {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    li.add {
      background-color: #9f9;
    }

    li.subtract {
      background-color: #f99;
    }
  </style>
</head>
<body>
  <h1>Branch Diff: <?php echo MASTER_BRANCH; ?>...<?php echo htmlentities($branch, ENT_QUOTES); ?></h1>
  <div id="diff">
<?php
  $out = array();
  $ret = 0;
  exec($cmd, $out, $ret);
  if (0 === $ret) {
    echo render_output($out);
  }
  else {
    echo <<<HTML
<h2>Error!</h2>
<p>Please try again later</p>

HTML;
  }
?>
  </div>
</body>
</html>

