<!DOCTYPE html>
<html>
<head>
  <title>ROOT</title>
  <style>
    * {
      font-family: Tahoma;
    }
    body {
      max-width: 100%;
      width: 100%;
    }
    h1 {
      font-size: 3em;
    }
    .company {
      z-index:0;
    }
    ul {
      margin: 0px;
      padding: 0px;
      list-style-position: inside;
    }
    .company-node {
      box-sizing: border-box;
      background-color: #6CD9EA;
      float: left;
      font-size: 2em;
      list-style: none;
      min-height: 250px;
      margin: 0 1% 1% 0;
      padding: 1%;
      position: relative;
      width: 19%;
    }
    .year {
      font-size: 0.8em;
      margin-left: 5%;
    }
    .year-node:hover {
      text-decoration: underline;
    }
    .year-node:hover .project {
      display: block;
      display: relative;
      z-index: 10;
    }
    .project {
      background-color: #6CD9EA;
      font-size: 0.7em;
      display: none;
      margin-left: 5%;
      z-index: 10;
      position: relative;
    }
  </style>
</head>
<body>
  <h1>Lista de projetos</h1>
  <?php
    $dirs = [];
    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('.'), RecursiveIteratorIterator::SELF_FIRST);
    $objects->setMaxDepth(2);//how many dirs should I crawl?
    foreach($objects as $file) {
      if(
          $file->isDir() &&
          $file->getFileName() != '.' &&
          $file->getFileName() != '..' &&
          //insira aqui a lista de palavras a ser ignoradas
          strpos($file->getPathname(), 'git') === FALSE
      ) {
        $item = substr($file->getPathname(),2);
        $path = explode('/', $item);

        if(count($path) == 1) {
          $dirs[$path[0]] = [];
        }
        if(count($path) == 2) {
          $dirs[$path[0]][$path[1]] = [];
        }
        if(count($path) == 3) {
          $dirs[$path[0]][$path[1]][$path[2]] = $file->getPathname();
        }
      }
    }
  ?>
  <ul class="campany">
    <?php foreach($dirs as $i => $dir): ?>
    <?php if(count($dir) > 0): ?>
    <li class="company-node">
      <?php echo $i ?>
      <ul class="year">
        <?php foreach($dir as $j => $subdir): ?>
        <li class="year-node">
          <?php echo $j ?>
          <ul class="project">
            <?php foreach($subdir as $k => $subsubdir): ?>
            <li class="project-node"><a href="<?php echo $subsubdir ?>"><?php echo $k ?></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
        <?php endforeach; ?>
      </ul>
    </li>
    <?php endif ?>
    <?php endforeach; ?>
  </ul>
</body>
</html>