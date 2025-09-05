<?php
namespace api\enums;

enum TgParseMode:string
{
    case HTML = 'HTML';
    case MARKDOWN = 'MarkdownV2';
}