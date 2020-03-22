<?php

namespace Dorcas\ModulesLibrary\Models;

use Illuminate\Database\Eloquent\Model;

class ModulesLibraryVideos extends Model
{
	protected $table = 'mda_videos';
	protected $connection = 'dorcas-api';

    protected $fillable = [
        'partner_id',
        'resource_uuid',
        'resource_category',
        'resource_subcategory',
        'resource_type',
        'resource_subtype',
        'resource_thumb',
        'resource_source',
        'resource_title',
        'resource_description'
    ];




}
