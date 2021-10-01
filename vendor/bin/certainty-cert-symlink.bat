@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../paragonie/certainty/bin/certainty-cert-symlink
php "%BIN_TARGET%" %*
