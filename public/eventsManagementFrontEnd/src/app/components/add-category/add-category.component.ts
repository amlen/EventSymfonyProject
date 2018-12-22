import { Component, OnInit } from '@angular/core';
import { Category } from 'src/app/classes/category';
import { Router } from '@angular/router';
import { CategoryService } from 'src/app/services/category.service';

@Component({
  selector: 'app-add-category',
  templateUrl: './add-category.component.html',
  styleUrls: ['./add-category.component.css']
})
export class AddCategoryComponent implements OnInit {

  category: Category;

  constructor(private router: Router,
              private categoryService: CategoryService) {
    this.category = new Category();
  }

  ngOnInit() {
  }

  onSubmit() {
    if (!this.category.name) {
      alert('You forgot to add a name!');
      return;
    } else if (!this.category.description) {
      alert('You forgot to add a description!');
      return;
    } else {
      this.categoryService.postCategory(this.category).subscribe(
        (data) => {
          if (data.valid === true) {
            alert('The category is well added');
            this.router.navigate(['/categories']);
          } else {
            console.log('error');
          }
        }
      );
    }
}

}
