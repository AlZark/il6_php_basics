<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class Catalog extends AbstractModel implements ModelInterfaces
{
    private string $title;

    private string $description;

    private int $manufacturer_id;

    private int $model_id;

    private float $price;

    private int $year;

    private int $type_id;

    private int $user_id;

    private string $img;

    private int $active;

    private string $slug;

    private string $created_at;

    private string $vin;

    private int $views;

    private int $mileage;

    private string $color;

    protected const TABLE = 'ads';

    public function __construct(?int $id = null)
    {
        if ($id !== null) {
            $this->load($id);
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getManufacturerId(): int
    {
        return $this->manufacturer_id;
    }

    public function setManufacturerId($manufacturer_id): void
    {
        $this->manufacturer_id = $manufacturer_id;
    }

    public function getModelId(): int
    {
        return $this->model_id;
    }

    public function setModelId(int $model_id): void
    {
        $this->model_id = $model_id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getTypeId(): int
    {
        return $this->type_id;
    }

    public function setTypeId(int $type_id): void
    {
        $this->type_id = $type_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getImg(): string
    {
        return $this->img;
    }

    public function setImg(string $img): void
    {
        $this->img = $img;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getVin(): string
    {
        return $this->vin;
    }

    public function setVin(string $vin): void
    {
        $this->vin = $vin;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setViews(int $views): void
    {
        $this->views = $views;
    }

    public function getMileage(): int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): void
    {
        $this->mileage = $mileage;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function assignData(): void
    {
        $this->data = [
            'title' => $this->title,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturer_id,
            'model_id' => $this->model_id,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->type_id,
            'user_id' => $this->user_id,
            'active' => $this->active,
            'img' => $this->img,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'vin' => $this->vin,
            'views' => $this->views,
            'mileage' => $this->mileage,
            'color' => $this->color,
        ];
    }

    public function load(int $id): object
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = (int)$data['id'];
        $this->title = (string)$data['title'];
        $this->description = (string)$data['description'];
        $this->manufacturer_id = (int)$data['manufacturer_id'];
        $this->model_id = (int)$data['model_id'];
        $this->price = (float)$data['price'];
        $this->year = (int)$data['year'];
        $this->type_id = (int)$data['type_id'];
        $this->active = (int)$data['active'];
        $this->user_id = (int)$data['user_id'];
        $this->img = (string)$data['img'];
        $this->slug = (string)$data['slug'];
        $this->created_at = (string)$data['created_at'];
        $this->vin = (string)$data['vin'];
        $this->color = (string)$data['color'];
        $this->mileage = (int)$data['mileage'];
        $this->views = (int)$data['views'];

        $user = new User();
        $this->user = $user->load($this->user_id);
        return $this;
    }

    public function getAd($id): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('id', $id)->get();
        $ads = [];
        foreach ($data as $element) {
            $ad = new Catalog(); // Kreipaimaes v4l nes loadas uzkrauna objekta kiekvienam miestui ir galim naudoti objekto funkcijas
            $ad->load((int)$element['id']);
            $ads[] = $ad;
        }
        return $ads;
    }

    public static function getAllAds(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $ads = [];
        foreach ($data as $element) {
            $ad = new Catalog();
            $ad->load((int)$element['id']);
            $ads[] = $ad;
        }
        return $ads;
    }

    public function loadBySlug(string $slug): ?catalog
    {
        $db = new DBHelper();
        $rez = $db->select('id')->from(self::TABLE)->where('slug', $slug)->getOne();
        if (!empty($rez)) {
            $this->load((int)$rez['id']);
            return $this;
        } else {
            return null;
        }
    }

    //add ability to null out limit and offset
    public static function getAllActiveAds(int    $limit, int $offset,
                                           string $order = 'created_at DESC', string $search = ''): array
    {
        list($orderBy, $direction) = explode(' ', $order);

        $db = new DBHelper();
        $data = $db
            ->select()
            ->from(self::TABLE)
            ->where('active', 1)
            ->andWhere('title', '%' . $search . '%', 'LIKE')
            ->Orwhere('active', 1)
            ->andWhere('description', '%' . $search . '%', 'LIKE')
            ->order($orderBy, $direction)
            ->limit($limit)
            ->offset($offset)
            ->get();
        $ads = [];

        foreach ($data as $element) {
            $ad = new Catalog();
            $ad->load((int)$element['id']);
            $ads[] = $ad;
        }
        return $ads;
    }

    public static function getAllFavoriteAds(int $userId, int $limit, int $offset): array
    {
        $favoriteAds = new DBHelper();
        $favorites = $favoriteAds
            ->select()
            ->from('favorite_ads')
            ->where('user_id', $userId)
            ->limit($limit)
            ->offset($offset)
            ->get();

        foreach ($favorites as $favorite) {
            $ad = new Catalog();
            $ad->load((int)$favorite['ad_id']);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function getPopularAds(int $limit): array
    {
        $db = new DBHelper();
        $data = $db->select('id')
            ->from(self::TABLE)
            ->where('active', 1)
            ->order('views', 'DESC')
            ->limit($limit)
            ->get();
        $ads = [];
        foreach ($data as $element) {
            $ad = new Catalog();
            $ad->load((int)$element['id']);
            $ads[] = $ad;
        }
        return $ads;
    }

    public static function getLatestAds(int $limit): array
    {
        $db = new DBHelper();
        $data = $db->select('id')
            ->from(self::TABLE)
            ->where('active', 1)
            ->order('created_at', 'DESC')
            ->limit($limit)
            ->get();
        $ads = [];
        foreach ($data as $element) {
            $ad = new Catalog();
            $ad->load((int)$element['id']);
            $ads[] = $ad;
        }
        return $ads;
    }

    public static function getRelatedAds(int $id): array
    {
        $ad = new Catalog();
        $ad->load($id);

        $db = new DBHelper();
        $data = $db
            ->select('id, created_at')
            ->from(self::TABLE)
            ->where('model_id', $ad->getModelId())
            ->andWhere('id', $id, ' != ')
            ->orWhere('title', '%' . $ad->getTitle() . '%', ' LIKE ')
            ->andWhere('id', $id, ' != ')
            ->limit(5)
            ->get();
        $ads = [];
        foreach ($data as $element) {
            $ad = new Catalog();
            $ad->load((int)$element['id']);
            $ads[] = $ad;
        }
        return $ads;
    }

    public static function totalAds(): int
    {
        $total = new DBHelper();
        $rez = $total
            ->select('COUNT(id)')
            ->from(self::TABLE)
            ->get();

        return (int)$rez[0][0];
    }

    public static function totalActiveAds(string $search = ""): int
    {
        $total = new DBHelper();
        $rez = $total
            ->select('COUNT(id)')
            ->from(self::TABLE)
            ->where('active', '1')
            ->andWhere('title', '%' . $search . '%', 'LIKE')
            ->orWhere('active', '1')
            ->andWhere('description', '%' . $search . '%', 'LIKE')
            ->get();

        return (int)$rez[0][0];
    }

    public static function totalNewAds(): int
    {
        $date = Date("Y-m-d H:i:s");
        $date = strtotime($date);
        $date = date("Y-m-d H:i:s", strtotime("-7 day", $date));

        $total = new DBHelper();
        $rez = $total
            ->select('COUNT(id)')
            ->from(self::TABLE)
            ->where('created_at', $date, '>=')
            ->get();

        return (int)$rez[0][0];
    }

}