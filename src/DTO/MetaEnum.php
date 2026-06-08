<?php

namespace Lix\DTO;

enum LinkMetaEnum: string
{
    case META_TITLE              = 'title';
    case META_OG_TITLE           = 'og:title';
    case META_DESCRIPTION        = 'description';
    case META_OG_DESCRIPTION     = 'og:description';
    case META_KEYWORDS           = 'keywords';
    case META_OG_IMAGE           = 'og:image';
}
