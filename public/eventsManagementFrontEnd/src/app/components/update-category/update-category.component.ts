import { Component, OnInit } from '@angular/core';
import { Category } from 'src/app/classes/category';
import { Router, ActivatedRoute } from '@angular/router';
import { CategoryService } from 'src/app/services/category.service';

@Component({
  selector: 'app-update-category',
  templateUrl: './update-category.component.html',
  styleUrls: ['./update-category.component.css']
})
export class UpdateCategoryComponent implements OnInit {
  category: Category;

  constructor(private route: ActivatedRoute,
              private router: Router,
              private categoryService: CategoryService) { }

  ngOnInit() {
    this.getCategory();
  }

  getCategory() {
    // tslint:disable-next-line:prefer-const
    let id = this.route.snapshot.paramMap.get('id');
    this.categoryService.getCategory(id).subscribe(
      (data) => {
        this.category = data;
      },
      (err) => {
        console.log(err);
      }
    );
  }

  onSubmit() {
    this.categoryService.putCategory(this.category.id, this.category).subscribe(
      (data) => {
        alert('The category is well updated');
        this.router.navigate(['/categories']);
      },
      (err) => {
        alert('Error something wrong ');
        console.log(err);
      }
    );
  }
}
