# See https://stackoverflow.com/questions/7069682
while getopts ":a:" opt; do
  case $opt in
    a)
      ENVFILE="$HOME/.digitalocean-php/$OPTARG.env" >&2
      shift
      ;;
    \?)
      ;;
    :)
      ;;
  esac
done

if [ -z "$ENVFILE" ]; then
  ENVFILE="$HOME/.digitalocean-php/token.env"
fi
