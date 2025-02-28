#! /bin/bash
/usr/bin/unzip 7510008_R2_ETA.zip -d .
/usr/local/bin/dx -script 7510008_R2_ETA.net 
/bin/tar czf 7510008_R2_ETA.tar.gz 7510008_R2_ETA.dx
