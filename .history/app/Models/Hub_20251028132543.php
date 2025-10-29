namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'file_path',
        'link_url',
        'certification_id',
        'section_id',
        // remove user_id if using pivot
    ];

    protected $casts = [
        'file_path' => 'array', // store uploaded files as JSON
    ];

    // Many-to-many: hubs ↔ users (students)
    public function users()
    {
        return $this->belongsToMany(User::class, 'hub_user', 'hub_id', 'user_id');
    }

    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
