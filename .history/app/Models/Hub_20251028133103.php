namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
use HasFactory;

protected $fillable = [
'title', 'description', 'type', 'file_path', 'link_url',
'certification_id', 'section_id',
];

// Many-to-many with users
public function users()
{
return $this->belongsToMany(User::class, 'hub_user', 'hub_id', 'user_id');
}
}