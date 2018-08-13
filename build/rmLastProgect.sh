#!/bin/bash

a=`ls /home/bashakkord/htdocs | wc -l`
b=4
p=$1

if [ "$a" -gt "$b" ]
then
 `echo $p | sudo -S chmod -R 0777 '/home/bashakkord/htdocs'`
 `ls /home/bashakkord/htdocs -t | tail -1 | xargs -i rm -R '/home/bashakkord/htdocs/{}'`
fi


echo "$a"



