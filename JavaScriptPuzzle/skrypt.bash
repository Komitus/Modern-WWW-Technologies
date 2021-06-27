#!/bin/bash
FILES=/home/adam/Desktop/NTWWW/L2/Gra/images_small/*
for f in $FILES
do
  # take action on each file. $f store current file name
  convert  -retile_height 20% $f $f
  cat $f
done

