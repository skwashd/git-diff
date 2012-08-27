This is a simple PHP script for comparing a git branch to an arbitary branch.

It assumes that all branches are merged from the same branch, which is why it
uses ... for the diff.  This script adopts the unix philosophy of do one thing
and do it well.

Install
To install the script check it out and copy config.example.php to config.php
and update it to match your environment.  You can include some logic in this
file if you want to use one instance of the script for multiple repos.

This code is distributed under the terms of the WTFPL. http://sam.zoy.org/wtfpl/

