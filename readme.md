## 快速开始

### 修改 model 使 model 支持 querybuilder

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hooklife\QueryBuilder\QueryBuildable;

class User extends Model
{
    use QueryBuildable;
}
```

### 创建 QueryBuilder
Querybuilder 匹配规则 为 {ModelName}QueryBuilder.php，例如下面生成的 QueryBuilder 会自动匹配 UserModel
```shell
php artisan make:queryBuilder UserQueryBuilder
```


### 使用 QueryBuilder

```php
 User::queryBuilder($request->all())->get()
```

### 编写 QueryBuilder

用户的参数会自动传入对应的 QueryBuilder , 并且会自动调用请求key对应的方法，参数喂请求 key 的内容

下面为一个简单例子,传入数组为 ``` ["user_id":1] ```,则 QueryBuilder 会自动调用 userId 方法，参数 $value 为1

```php

namespace App\QueryBuilders;

use Hooklife\QueryBuilder\QueryBuilder;

class UserQueryBuilder extends QueryBuilder
{
    public function userId($value){
        $this->query->where('user_id',$value)
    }
}
```

## 自带插件
### filterable
```php
namespace App\QueryBuilders;
use Hooklife\QueryBuilder\Concerns\Filterable;
class UserQueryBuilder extends QueryBuilder
{
    use Filterable;
    public array $simpleFilters = [
        'name' => ['like','%?%']
        'status'
    ];
}
```
以上的例子相当于
```php
namespace App\QueryBuilders;
class UserQueryBuilder extends QueryBuilder
{
    public function name($value){
        $this->query->where('name','like','%'.$value.'%');
    } 
    
    public function status($value){
        $this->query->where('status',$value);
    }
}
```

###sortable
```php
namespace App\QueryBuilders;
use Hooklife\QueryBuilder\Concerns\Sortable;
class UserQueryBuilder extends QueryBuilder
{
    use Sortable;
    protected $sortPrefix = 'sort_'
    public array $simpleSorts = [
        'name',
        'created_at' => 'desc'
    ];
}
```

以上的例子相当于
```php
namespace App\QueryBuilders;
class UserQueryBuilder extends QueryBuilder
{
    public function boot(){
        $this->query->sortBy('created_at','desc');
    }
    public function sortName($value){
        $this->query->orderBy('name',$value);
    } 
    
}
```