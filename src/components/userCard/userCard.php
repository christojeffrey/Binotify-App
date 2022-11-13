<?php
    function userCard($args){
        // $username, $email, $is_admin, $name

        extract($args);
        $role  = $is_admin ? "Admin" : "User";
        $html = <<<"EOT"
        <style>
        .user-desc{
            width: 15%;
        }
        .user-card{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border: 1px solid black;
            margin: 1rem;
        }
        </style>
            <div class="flex flex-row user-card">
                    <div class="user-desc">
                        $name
                    </div>
                    <div class="user-desc">
                        $username
                    </div>
                    <div class="user-desc">
                        $email
                    </div>
                    <div class="user-desc">
                        $role
                    </div>
            </div>
        EOT;
        return $html;
    }
?>