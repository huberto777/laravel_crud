<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\{Album, Article, Category, Comment, Contact, Photo, Role, Tag, User, Video};
use Storage;

use App\Mail\Email;
use Illuminate\Support\Facades\Mail;

class BaseRepository implements BaseRepositoryInterface
{ }
