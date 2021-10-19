<?php

namespace App\Twill\Capsules\Menus\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kalnoy\Nestedset\NodeTrait;

class MenuItem extends Model implements Sortable
{
    use HasMedias, HasFiles, HasPosition, HasFactory, HasPosition, NodeTrait, HasRelated;

    protected $fillable = [
        'published',
        'title',
        'description',
        'position',
        'menu_id',
        'target',
        'url',
        'route_path',
        'link_target'
    ];

    public $mediasParams = [
        'cover' => [
            'desktop' => [
                [
                    'name' => 'desktop',
                    'ratio' => 16 / 9,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 1,
                ],
            ],
            'flexible' => [
                [
                    'name' => 'free',
                    'ratio' => 0,
                ],
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
                [
                    'name' => 'portrait',
                    'ratio' => 3 / 5,
                ],
            ],
        ],
    ];

    public function scopeType($query)
    {
        return $query->where('menu_id', session('currentMenuAdmin'));
    }

    /**
     * @return BelongsTo
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public static function saveTreeFromIds($nodeTree)
    {
        $nodeModels = self::all();
        $nodeArrays = self::flattenTree($nodeTree);

        foreach ($nodeArrays as $nodeArray) {
            $nodeModel = $nodeModels->where('id', $nodeArray['id'])->first();

            if ($nodeArray['parent_id'] === null) {
                if (!$nodeModel->isRoot() || $nodeModel->position !== $nodeArray['position']) {
                    $nodeModel->position = $nodeArray['position'];
                    $nodeModel->saveAsRoot();
                }
            } else {
                if ($nodeModel->position !== $nodeArray['position'] || $nodeModel->parent_id !== $nodeArray['parent_id']) {
                    $nodeModel->position = $nodeArray['position'];
                    $nodeModel->parent_id = $nodeArray['parent_id'];
                    $nodeModel->save();
                }
            }
        }
    }

    public static function flattenTree(array $nodeTree, int $parentId = null)
    {
        $nodeArrays = [];
        $position = 0;

        foreach ($nodeTree as $node) {
            $nodeArrays[] = [
                'id' => $node['id'],
                'position' => $position++,
                'parent_id' => $parentId,
            ];

            if (count($node['children']) > 0) {
                $childArrays = self::flattenTree($node['children'], $node['id']);
                $nodeArrays = array_merge($nodeArrays, $childArrays);
            }
        }

        return $nodeArrays;
    }
}
