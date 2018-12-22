import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, ObservableInput } from 'rxjs';
import { Category } from 'src/app/classes/category';



@Injectable({
  providedIn: 'root'
})

export class CategoryService {
  private url = 'http://localhost/eventsManagement/public/index.php/api/';

  constructor(private http: HttpClient) { }

  getCategories(): Observable<Category[]> {
    return this.http.get<Category[]>(this.url + 'categories', { responseType: 'json' });
  }

  getCategory(id: string): Observable<Category> {
    return this.http.get<Category>(this.url + 'category/' + id, { responseType: 'json' });
  }

  putCategory(id: number, category: Category): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };

    return this.http.put(this.url + 'updateCategory/' + id, category, httpOptions);
  }

  postCategory(category: Category): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };

    return this.http.post<Category>(this.url + 'addCategory', category, httpOptions);
  }
  deleteCategory(id): Observable<any> {
    return this.http.delete(this.url +  'deleteCategory/' + id);
  }
}
