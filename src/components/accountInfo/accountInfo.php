<?php
  function accountInfo($args){
    // $username

    extract($args);
    if ($username) {
      $content = "Hi, " . $username . "!";
    } else {
      $content = "Guest";
    }
    $html = <<<EOT
    <style>
    .account-info-container{
      text-align: right;
    }

    .account-info-label {
      margin-right: 20px;
      color: white;
      font-size: 20px
      font-weight: 300;
      padding: 20px
      
    }
    </style>
    <div class="account-info-container">
      <p class="account-info-label">
        $content
      </p>
    </div>
    EOT;
    return $html;
  }