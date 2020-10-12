cd /etc/openhab2/commands/arris-tg3442-reboot
out=$(python3 arris-tg3442-reboot.py -u admin -p YVDM3WAA -t http://192.168.100.1 -a uptime | grep -v Auto-detected)

if [ $out -lt 5 ]; then
  echo -n "Router rebooted at " >> /var/log/openhab2/cablerouter.log
  date +"%Y%m%d %H:%M:%S" >> /var/log/openhab2/cablerouter.log
fi

echo $out
