#!/bin/bash

echo "Please, write the networks file location: "
read FILELOCATION

echo "Please, write the script file location: "
read SCRIPTLOCATION

echo "Please, write the timeout value: "
read TIMEOUT

if [ -f "$FILELOCATION" ]; then
                echo "### Preparing the ambient for this challenge!"
                sleep 3
                while true; do
                                for i in $(cat $FILELOCATION); do
                                                echo "-- Scanning $i network IP"
                                                if [ -f "$SCRIPTLOCATION" ]; then
                                                                if [ -z "$TIMEOUT" ]; then
                                                                                $(python $SCRIPTLOCATION --net $i)
                                                                                sleep 1
                                                                else
                                                                                $(python $SCRIPTLOCATION --net $i --timeout $TIMEOUT)
                                                                                sleep 1
                                                                fi
                                                else
                                                                echo "Please, write a valide script location!"
                                                fi
                                done
                done
else
                echo "Please, write a valid file path location!"
fi
