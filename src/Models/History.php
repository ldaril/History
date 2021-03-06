<?php

namespace TypiCMS\Modules\History\Models;

use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Presenters\ModulePresenter;
use TypiCMS\Modules\Users\Models\User;

class History extends Base
{
    use PresentableTrait;

    protected $table = 'history';
    protected $presenter = ModulePresenter::class;

    protected $guarded = ['id', 'exit'];

    protected $appends = ['user_name', 'href'];

    protected $casts = [
        'old' => 'object',
        'new' => 'object',
    ];

    /**
     * lists.
     */
    public $order = 'id';
    public $direction = 'desc';

    /**
     * History item morph to model.
     */
    public function historable()
    {
        return $this->morphTo();
    }

    /**
     * History item belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Append user name.
     *
     * @return string\null
     */
    public function getUserNameAttribute()
    {
        if ($this->user) {
            return $this->user->first_name.' '.$this->user->last_name;
        }
    }

    /**
     * Append href.
     *
     * @return string|null
     */
    public function getHrefAttribute()
    {
        if ($this->historable) {
            return $this->historable->editUrl();
        }
    }
}
