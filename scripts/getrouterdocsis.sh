cd /etc/openhab2/commands/arris-tg3442-reboot
out=$(python3 arris-tg3442-reboot.py -u admin -p YVDM3WAA -t http://192.168.100.1 -a docsis | grep -v Auto-detected)

echo $out >> /var/log/openhab2/cablerouter-docsis.log

echo $out
