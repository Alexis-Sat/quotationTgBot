<?php
namespace api\enums;

enum TgMethods:string
{
    case SEND_TEXT = '/sendMessage';
    case SEND_PHOTO = '/sendPhoto';
}