@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../2bj/phanybar/bin/phanybar
php "%BIN_TARGET%" %*
