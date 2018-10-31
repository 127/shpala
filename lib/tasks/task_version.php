<?php
echo system("git describe --exact-match --tags $(git log -n1 --pretty='%h')");	
?>